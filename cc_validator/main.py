from fastapi import FastAPI, HTTPException, Query
from fastapi.staticfiles import StaticFiles
from fastapi.responses import FileResponse
from pydantic import BaseModel
import json
from validators import luhn_check, detect_brand, mask_pan
from typing import Optional

app = FastAPI(title="CC Validator (Demo)")

try:
    with open('bin_db.json', 'r') as f:
        BIN_DB = {entry['bin']: entry for entry in json.load(f)}
except Exception:
    BIN_DB = {}


class LookupResponse(BaseModel):
    bin: str
    brand: Optional[str]
    card_type: Optional[str]
    level: Optional[str]
    issuer: Optional[str]
    country: Optional[str]
    active: Optional[bool]
    limits: Optional[dict]
    luhn_valid: bool
    masked_pan: str


class BinLookupResponse(BaseModel):
    bin: str
    brand: Optional[str]
    card_type: Optional[str]
    level: Optional[str]
    issuer: Optional[str]
    country: Optional[str]
    active: Optional[bool]
    limits: Optional[dict]


@app.get('/lookup', response_model=LookupResponse)
def lookup(pan: str = Query(..., min_length=6, description="Card PAN (will be masked)")):
    digits = ''.join(ch for ch in pan if ch.isdigit())
    if len(digits) < 6:
        raise HTTPException(status_code=400, detail='PAN must include at least 6 digits')

    bin6 = digits[:6]
    entry = BIN_DB.get(bin6)
    brand = detect_brand(digits)
    resp = {
        'bin': bin6,
        'brand': brand or (entry.get('brand') if entry else None),
        'card_type': entry.get('card_type') if entry else None,
        'level': entry.get('level') if entry else None,
        'issuer': entry.get('issuer') if entry else None,
        'country': entry.get('country') if entry else None,
        'active': entry.get('active') if entry else None,
        'limits': entry.get('limits') if entry else None,
        'luhn_valid': luhn_check(digits),
        'masked_pan': mask_pan(digits),
    }
    return resp


@app.get('/bin_lookup', response_model=BinLookupResponse)
def bin_lookup(bin: str = Query(..., min_length=6, max_length=6, description='First 6 digits (BIN)')):
    if not bin.isdigit() or len(bin) != 6:
        raise HTTPException(status_code=400, detail='BIN must be 6 digits')
    entry = BIN_DB.get(bin)
    resp = {
        'bin': bin,
        'brand': entry.get('brand') if entry else None,
        'card_type': entry.get('card_type') if entry else None,
        'level': entry.get('level') if entry else None,
        'issuer': entry.get('issuer') if entry else None,
        'country': entry.get('country') if entry else None,
        'active': entry.get('active') if entry else None,
        'limits': entry.get('limits') if entry else None,
    }
    return resp


# Serve a small client-side UI that keeps PAN in-browser.
app.mount('/static', StaticFiles(directory='static'), name='static')


@app.get('/')
def ui_index():
    return FileResponse('static/index.html')

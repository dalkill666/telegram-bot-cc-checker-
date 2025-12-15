from fastapi import FastAPI, HTTPException, Query
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

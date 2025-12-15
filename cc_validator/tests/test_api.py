from fastapi.testclient import TestClient
from main import app


client = TestClient(app)


def test_bin_lookup_valid():
    r = client.get('/bin_lookup?bin=411111')
    assert r.status_code == 200
    j = r.json()
    assert j['bin'] == '411111'
    assert j['issuer'] == 'Demo Bank A'


def test_bin_lookup_invalid():
    r = client.get('/bin_lookup?bin=abc123')
    assert r.status_code == 400

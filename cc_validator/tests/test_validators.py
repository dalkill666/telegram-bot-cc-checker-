import json
from validators import luhn_check, detect_brand, mask_pan

with open('bin_db.json', 'r') as f:
    BIN_DB = {entry['bin']: entry for entry in json.load(f)}


def test_luhn_valid():
    assert luhn_check('4111111111111111') is True
    assert luhn_check('378282246310005') is True


def test_luhn_invalid():
    assert luhn_check('4111111111111112') is False


def test_detect_brand():
    assert detect_brand('4111111111111111') == 'Visa'
    assert detect_brand('5555555555554444') == 'MasterCard'
    assert detect_brand('378282246310005') == 'American Express'


def test_mask_pan():
    assert mask_pan('4111111111111111').endswith('1111')


def test_bin_db_presence():
    assert '411111' in BIN_DB
    assert BIN_DB['411111']['issuer'] == 'Demo Bank A'

from typing import Optional

def luhn_check(pan: str) -> bool:
    pan = ''.join(ch for ch in pan if ch.isdigit())
    if not pan:
        return False
    total = 0
    reverse_digits = pan[::-1]
    for i, ch in enumerate(reverse_digits):
        d = int(ch)
        if i % 2 == 1:
            d = d * 2
            if d > 9:
                d -= 9
        total += d
    return total % 10 == 0

def detect_brand(pan: str) -> Optional[str]:
    pan = pan.strip()
    if not pan:
        return None
    if pan.startswith('4'):
        return 'Visa'
    if pan[:2] in ('51','52','53','54','55'):
        return 'MasterCard'
    if pan.startswith('34') or pan.startswith('37'):
        return 'American Express'
    if pan.startswith('6'):
        return 'Discover'
    return None

def mask_pan(pan: str) -> str:
    digits = ''.join(ch for ch in pan if ch.isdigit())
    if len(digits) <= 4:
        return '*' * len(digits)
    return '*' * (len(digits) - 4) + digits[-4:]

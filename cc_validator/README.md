CC Validator Service (demo)
================================

Minimal FastAPI-based credit-card validation service intended for fraud-prevention workflows. Implements format checks (Luhn), expiry, CVV patterns, BIN lookup, simple risk scoring, and an example tokenization flow.

Security notes
- This project is a demo. Do NOT use it in production without implementing full PCI DSS safeguards: TLS, no PAN logging, tokenization via PCI-certified provider, proper key management, and environment hardening.

Quick start
1. Create and activate a Python venv

```bash
cd cc_validator
python -m venv .venv
source .venv/bin/activate
pip install -r requirements.txt
uvicorn main:app --reload
```

Run tests:

```bash
pytest -q
```

API
- `GET /lookup?pan=<PAN>` — returns masked PAN, BIN (first 6), brand, issuer info, active flag, limits, Luhn validity.

Important: This demo intentionally avoids storing or logging full PANs.

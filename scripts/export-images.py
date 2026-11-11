#!/usr/bin/env python3
"""Export local SVG placeholders to media-library friendly PNG files.
Usage: pip install cairosvg; python scripts/export-images.py
"""
from pathlib import Path
try:
    import cairosvg
except ImportError:
    raise SystemExit("Run: pip install cairosvg")
root = Path(__file__).resolve().parents[1]
source = root / "assets" / "img"
target = root / "assets" / "uploads-ready"
target.mkdir(exist_ok=True)
for asset in source.glob("*.svg"):
    output = target / (asset.stem + ".png")
    cairosvg.svg2png(url=str(asset), write_to=str(output))
    print(f"{asset.name} → {output.relative_to(root)}")
print("Illustrations are placeholders. Replace with client-approved photos before launch.")

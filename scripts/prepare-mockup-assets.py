#!/usr/bin/env python3
"""Download exactly the three image sources and Font Awesome icons used in the supplied HTML.

Outputs:
  assets/uploads-ready/photos/{hero,production,product}.jpg
  assets/uploads-ready/icons/{name}.png (transparent)
  assets/icons/{name}.svg

All URLs are fixed and source-controlled; never accepts arbitrary admin-supplied URLs.
"""
from __future__ import annotations
from io import BytesIO
from pathlib import Path
from urllib.request import Request, urlopen
import time
import xml.etree.ElementTree as ET
from PIL import Image, ImageOps
import cairosvg

ROOT = Path(__file__).resolve().parents[1]
OUTPUT = ROOT / "assets" / "uploads-ready"
SVG_OUTPUT = ROOT / "assets" / "icons"

PHOTOS = {
    "hero": "https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80",
    "production": "https://images.unsplash.com/photo-1581092160562-40aa08e78837?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
    "product": "https://images.unsplash.com/photo-1582965348647-321a2c94d2c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80",
}

# Left: internal theme icon name; right: official Font Awesome Free 6.7.2 SVG path.
ICONS = {
    "phone": "solid/phone-flip",
    "telegram": "brands/telegram",
    "whatsapp": "brands/whatsapp",
    "factory": "solid/industry",
    "check-circle": "solid/circle-check",
    "tags": "solid/tags",
    "certificate": "solid/certificate",
    "search": "solid/magnifying-glass",
    "palette": "solid/palette",
    "handshake": "solid/handshake",
    "chart": "solid/chart-line",
    "check": "solid/check",
    "star": "solid/star",
    "chevron-down": "solid/chevron-down",
    "mail": "solid/envelope",
    "map-pin": "solid/location-dot",
    "menu": "solid/bars",
    "arrow-up": "solid/arrow-up",
}
VERSION = "6.7.2"
BASE = f"https://raw.githubusercontent.com/FortAwesome/Font-Awesome/{VERSION}/svgs/"

def download(url: str) -> bytes:
    for attempt in range(3):
        try:
            req = Request(url, headers={"User-Agent": "AMEZA-theme-assets/1.0", "Accept": "*/*"})
            with urlopen(req, timeout=35) as response:
                data = response.read(15 * 1024 * 1024 + 1)
                if len(data) > 15 * 1024 * 1024:
                    raise ValueError("File too large")
                return data
        except Exception as error:
            if attempt == 2:
                raise RuntimeError(f"Cannot download {url}: {error}") from error
            time.sleep(attempt + 1)
    raise AssertionError("Unreachable")

def save_photo(name: str, url: str) -> None:
    path = OUTPUT / "photos" / f"{name}.jpg"
    path.parent.mkdir(parents=True, exist_ok=True)
    try:
        data = download(url)
    except RuntimeError:
        if name != "product":
            raise
        # The original product photo URL now returns 404.
        replacement = "https://images.pexels.com/photos/9594148/pexels-photo-9594148.jpeg?auto=compress&cs=tinysrgb&w=800"
        data = download(replacement)
        print("Original product image is unavailable; replacement: Pexels 9594148")
    with Image.open(BytesIO(data)) as original:
        image = ImageOps.exif_transpose(original).convert("RGB")
        if image.width < 100 or image.height < 100:
            raise ValueError(f"Suspiciously small original photo: {name}")
        image.save(path, format="JPEG", quality=87, optimize=True)
    print(f"Photo: {path.relative_to(ROOT)} ({image.width}x{image.height})")

def save_icon(name: str, upstream: str) -> None:
    svg = download(BASE + upstream + ".svg")
    root = ET.fromstring(svg)
    if root.tag != "{http://www.w3.org/2000/svg}svg":
        raise ValueError(f"Unexpected SVG root: {name}")
    if b"<script" in svg or b"foreignObject" in svg:
        raise ValueError(f"Unexpected SVG active content: {name}")
    SVG_OUTPUT.mkdir(parents=True, exist_ok=True)
    (SVG_OUTPUT / (name + ".svg")).write_bytes(svg)
    png = cairosvg.svg2png(bytestring=svg, output_width=72)
    with Image.open(BytesIO(png)) as original:
        glyph = original.convert("RGBA")
        glyph.thumbnail((72, 72), Image.Resampling.LANCZOS)
        canvas = Image.new("RGBA", (72, 72), (0, 0, 0, 0))
        canvas.alpha_composite(glyph, ((72 - glyph.width) // 2, (72 - glyph.height) // 2))
        path = OUTPUT / "icons" / (name + ".png")
        path.parent.mkdir(parents=True, exist_ok=True)
        canvas.save(path, format="PNG", optimize=True)
    print(f"Icon: {name} ({upstream})")

if __name__ == "__main__":
    for name, url in PHOTOS.items():
        save_photo(name, url)
    for name, source in ICONS.items():
        save_icon(name, source)
    print("Downloaded source HTML photographs and matching Font Awesome icons.")

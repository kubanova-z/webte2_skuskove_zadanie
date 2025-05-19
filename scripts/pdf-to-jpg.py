import sys
import os
from pdf2image import convert_from_path

# Argumenty: cesta k PDF, výstupný priečinok, DPI
input_pdf = sys.argv[1]
output_dir = sys.argv[2]
dpi = int(sys.argv[3]) if len(sys.argv) > 3 else 150

# Vytvor výstupný priečinok, ak neexistuje
os.makedirs(output_dir, exist_ok=True)

# Konverzia strán na obrázky
images = convert_from_path(input_pdf, dpi=dpi)

# Uloženie jednotlivých obrázkov
for i, img in enumerate(images, start=1):
    output_path = os.path.join(output_dir, f"page_{i}.jpg")
    img.save(output_path, "JPEG")

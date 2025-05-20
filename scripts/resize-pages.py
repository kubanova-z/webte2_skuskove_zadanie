import sys
from PyPDF2 import PdfReader, PdfWriter

input_path = sys.argv[1]
output_path = sys.argv[2]
size_label = sys.argv[3]

# Definované rozmery v bodoch (1 bod = 1/72 inch)
sizes = {
    "A4": (595, 842),
    "A5": (420, 595),
    "A6": (297, 420)
}

width, height = sizes.get(size_label, sizes["A4"])

reader = PdfReader(input_path)
writer = PdfWriter()

for page in reader.pages:
    page.scale_to(width, height)
    writer.add_page(page)

with open(output_path, "wb") as f:
    writer.write(f)

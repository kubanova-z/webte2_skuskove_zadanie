import sys
import os
from PyPDF2 import PdfReader, PdfWriter

input_pdf = sys.argv[1]
output_dir = sys.argv[2]
split_size = int(sys.argv[3])

reader = PdfReader(input_pdf)
total_pages = len(reader.pages)
os.makedirs(output_dir, exist_ok=True)

for i in range(0, total_pages, split_size):
    writer = PdfWriter()
    for j in range(i, min(i + split_size, total_pages)):
        writer.add_page(reader.pages[j])

    output_path = os.path.join(output_dir, f"part_{i+1}.pdf")
    with open(output_path, "wb") as f:
        writer.write(f)

print(f"✅ Rozdelené do {len(range(0, total_pages, split_size))} súborov.")

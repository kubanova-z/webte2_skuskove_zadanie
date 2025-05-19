import sys
from PyPDF2 import PdfReader, PdfWriter

input_pdf = sys.argv[1]
pages_str = sys.argv[2]         # napr. "1,3,5"
angle = int(sys.argv[3])        # napr. 90
output_pdf = sys.argv[4]

pages_to_rotate = [int(p.strip()) - 1 for p in pages_str.split(',')]

reader = PdfReader(input_pdf)
writer = PdfWriter()

for i, page in enumerate(reader.pages):
    if i in pages_to_rotate:
        page.rotate(angle)
    writer.add_page(page)

with open(output_pdf, "wb") as f:
    writer.write(f)

print("✅ Otočenie strán hotové.")

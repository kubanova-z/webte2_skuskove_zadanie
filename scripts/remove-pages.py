import sys
from PyPDF2 import PdfReader, PdfWriter

# načítanie argumentov zo shellu
input_path = sys.argv[1]          # napr. 'storage/app/pdf/input.pdf'
pages_str = sys.argv[2]           # napr. '1,3,5'
output_path = sys.argv[3]         # napr. 'storage/app/pdf/output.pdf'

# prevedenie zoznamu strán na čísla -1 lebo python
pages_to_remove = [int(p.strip()) - 1 for p in pages_str.split(',')]

reader = PdfReader(input_path)
writer = PdfWriter()

for i, page in enumerate(reader.pages):
    if i not in pages_to_remove:
        writer.add_page(page)

with open(output_path, "wb") as f:
    writer.write(f)

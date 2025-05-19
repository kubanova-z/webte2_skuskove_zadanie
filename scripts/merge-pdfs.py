import sys
from PyPDF2 import PdfReader, PdfWriter

*args, output_path = sys.argv[1:] #ziskanie vsetkych argumentov
writer = PdfWriter()

for pdf_path in args:
    reader = PdfReader(pdf_path)
    for page in reader.pages:
        writer.add_page(page)

with open(output_path, "wb") as f:
    writer.write(f)

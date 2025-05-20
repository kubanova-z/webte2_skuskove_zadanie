import sys
from PyPDF2 import PdfReader, PdfWriter

input_path = sys.argv[1]
output_path = sys.argv[2]
password = sys.argv[3]

reader = PdfReader(input_path)
writer = PdfWriter()

for page in reader.pages:
    writer.add_page(page)

writer.encrypt(password)

with open(output_path, "wb") as f:
    writer.write(f)

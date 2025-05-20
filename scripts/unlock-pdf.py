import sys
from PyPDF2 import PdfReader, PdfWriter

input_path = sys.argv[1]
output_path = sys.argv[2]
password = sys.argv[3]

reader = PdfReader(input_path)

if reader.is_encrypted:
    try:
        reader.decrypt(password)
    except Exception as e:
        print("❌ Heslo je nesprávne alebo PDF nie je podporované.")
        sys.exit(1)

writer = PdfWriter()
for page in reader.pages:
    writer.add_page(page)

with open(output_path, "wb") as f:
    writer.write(f)

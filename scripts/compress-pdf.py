#!/usr/bin/env python3
import sys
from PyPDF2 import PdfReader, PdfWriter
from PyPDF2.generic import NameObject, ArrayObject, NumberObject

def compress(input_path, output_path, quality=50):
    reader = PdfReader(input_path)
    writer = PdfWriter()

    for page in reader.pages:
        writer.add_page(page)

    writer._root_object.update({
        NameObject('/Filter'): ArrayObject([NameObject('/FlateDecode')]),
        NameObject('/DecodeParms'): 
            writer._parser.get_object({
                NameObject('/Predictor'): NumberObject(12),
                NameObject('/Columns'): NumberObject(1),
                NameObject('/BitsPerComponent'): NumberObject(8),
                # use the quality arg to lower zlib's compression level (0–9),
                # but we invert it so 100% quality = zlib-level 1 (fast/large),
                # 10% quality = zlib-level 9 (slow/small).
                NameObject('/ZLibLevel'): NumberObject(int((100 - quality) * 9 / 90))
            })
    })

    with open(output_path, 'wb') as f:
        writer.write(f)

if __name__ == '__main__':
    in_file  = sys.argv[1]
    out_file = sys.argv[2]
    q        = int(sys.argv[3]) if len(sys.argv)>3 else 50
    compress(in_file, out_file, quality=q)

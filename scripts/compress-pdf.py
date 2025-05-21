import sys
import subprocess

def compress(input_path, output_path, quality=50):
    # Map quality (10–100) to PDFSETTINGS value
    quality_map = {
        100: '/prepress',
        75: '/printer',
        50: '/ebook',
        25: '/screen',
        10: '/screen',
    }

    # Pick closest match
    gs_quality = min(quality_map.keys(), key=lambda q: abs(quality - q))
    pdf_setting = quality_map[gs_quality]

    command = [
        'gs',
        '-sDEVICE=pdfwrite',
        '-dCompatibilityLevel=1.4',
        '-dPDFSETTINGS=' + pdf_setting,
        '-dNOPAUSE',
        '-dQUIET',
        '-dBATCH',
        f'-sOutputFile={output_path}',
        input_path,
    ]

    subprocess.run(command, check=True)

if __name__ == '__main__':
    in_file = sys.argv[1]
    out_file = sys.argv[2]
    q = int(sys.argv[3]) if len(sys.argv) > 3 else 50
    compress(in_file, out_file, quality=q)

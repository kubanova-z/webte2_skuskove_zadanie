import sys
from PIL import Image

*input_paths, output_path = sys.argv[1:]

images = [Image.open(path).convert("RGB") for path in input_paths]

first_image, rest = images[0], images[1:]

first_image.save(output_path, save_all=True, append_images=rest)

print(f"✅ PDF vytvorené z {len(images)} obrázkov.")

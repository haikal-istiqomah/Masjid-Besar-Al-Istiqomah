import os

# Konfigurasi file output
output_file = 'full_project_code.txt'

# Folder yang AKAN discan
allowed_extensions = ['.php', '.blade.php', '.js', '.css', '.json']

# Folder yang AKAN DIABAIKAN (Penting agar file tidak raksasa)
ignore_dirs = [
    '.git', 
    '.idea', 
    '.vscode', 
    'vendor', 
    'node_modules', 
    'storage', 
    'public/build', 
    'public/hot',
    'tests'
]

# File spesifik yang diabaikan
ignore_files = [
    'package-lock.json', 
    'composer.lock', 
    'scan_project.py', 
    output_file
]

def is_ignored(path):
    for ignore in ignore_dirs:
        if ignore in path.split(os.sep):
            return True
    return False

with open(output_file, 'w', encoding='utf-8') as outfile:
    for root, dirs, files in os.walk('.'):
        # Filter folder yang diabaikan
        dirs[:] = [d for d in dirs if d not in ignore_dirs]
        
        if is_ignored(root):
            continue

        for file in files:
            if file in ignore_files:
                continue
                
            # Cek ekstensi file
            if any(file.endswith(ext) for ext in allowed_extensions):
                file_path = os.path.join(root, file)
                
                try:
                    with open(file_path, 'r', encoding='utf-8') as infile:
                        content = infile.read()
                        
                        # Tulis nama file sebagai separator
                        outfile.write(f"\n\n{'='*50}\n")
                        outfile.write(f"FILE: {file_path}\n")
                        outfile.write(f"{'='*50}\n\n")
                        outfile.write(content)
                        print(f"Added: {file_path}")
                except Exception as e:
                    print(f"Skipping {file_path}: {e}")

print(f"\nSelesai! Semua kode disimpan di '{output_file}'.")
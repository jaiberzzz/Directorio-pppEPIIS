import zipfile
import os

def zip_folder(folder_path, output_path):
    with zipfile.ZipFile(output_path, 'w', zipfile.ZIP_DEFLATED) as zipf:
        for root, dirs, files in os.walk(folder_path):
            for file in files:
                file_path = os.path.join(root, file)
                # Compute relative path
                arcname = os.path.relpath(file_path, folder_path)
                # FORCE forward slashes for Linux compatibility
                arcname = arcname.replace(os.path.sep, '/')
                zipf.write(file_path, arcname)
    print(f"Created {output_path} successfully.")

if __name__ == "__main__":
    # Adjust these paths as needed
    source_folder = r"c:\xampp\htdocs\dppp01\directorio-practicantes\deploy_staging"
    output_zip = r"c:\xampp\htdocs\dppp01\directorio-practicantes\deploy_linux_compatible.zip"
    
    zip_folder(source_folder, output_zip)

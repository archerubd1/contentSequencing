<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Astraal | Cloud Upload</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #050a18; color: white; font-family: 'Segoe UI', sans-serif; }
        .upload-card { background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 15px; padding: 30px; margin-top: 50px; }
        .btn-primary { background: #3b82f6; border: none; }
        #status { font-family: monospace; font-size: 0.9rem; word-wrap: break-word; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="upload-card">
                    <h3 class="fw-bold mb-4">Cloud Asset Upload</h3>
                    <p class="text-secondary small">Upload videos or PDFs to <strong>duzmhtjr8</strong></p>
                    
                    <div class="mb-3">
                        <label class="form-label text-info">Step 1: Select File (Video/PDF)</label>
                        <input type="file" id="file-input" class="form-control bg-dark text-white border-secondary">
                    </div>
                    
                    <button type="button" onclick="uploadFile()" class="btn btn-primary w-100 fw-bold">STEP 2: START CLOUD UPLOAD</button>
                    
                    <div id="status" class="mt-4 p-3 bg-black rounded border border-secondary d-none"></div>
                    
                    <div class="mt-4 text-center">
                        <a href="dashboard.php" class="text-secondary text-decoration-none small">← Back to Command Center</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    async function uploadFile() {
        const fileInput = document.getElementById('file-input');
        const statusDiv = document.getElementById('status');
        
        if (fileInput.files.length === 0) {
            alert("Please select a file first!");
            return;
        }

        const file = fileInput.files[0];
        const formData = new FormData();
        
        // Using your cloud name and the 'content_sequencing' preset you created
        formData.append('file', file);
        formData.append('upload_preset', 'content_sequencing'); 

        statusDiv.classList.remove('d-none');
        statusDiv.innerText = "🚀 Uploading to Cloudinary... please wait.";

        try {
            const response = await fetch('https://api.cloudinary.com/v1_1/duzmhtjr8/upload', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.secure_url) {
                statusDiv.innerHTML = `
                    <span class="text-success fw-bold">✅ SUCCESS!</span><br><br>
                    <span class="text-white small">This URL fixes your rendering issue:</span><br>
                    <a href="${data.secure_url}" target="_blank" class="text-primary text-break">${data.secure_url}</a>
                    <br><br><span class="text-warning small">Copy this URL to your database!</span>
                `;
            } else {
                statusDiv.innerText = "❌ Error: " + (data.error.message || "Upload failed");
            }
        } catch (error) {
            statusDiv.innerText = "❌ Network Error. Check your internet connection.";
            console.error(error);
        }
    }
    </script>
</body>
</html>
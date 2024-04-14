<!-- resources/views/pdf_template.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <style>
        /* Add your PDF styling here */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td,h1 {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        h3 {
            padding: 8px;
            text-align: center;
        }


        th {
            background-color: #f2f2f2;
        }
        .download-link {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
        }

        .download-link:hover {
            background-color: #45a049;
        }

    </style>
</head>
<body>
<h1>QR</h1>

<table style="margin-top: 40px">
    <thead>
    <tr>

        <th>link</th>
        <th>QR</th>
        <th>Download</th>


        <!-- Add more columns as needed -->
    </tr>
    </thead>
    <tbody>
    <a href="#" class="download-link" style="display: flex;margin:  auto;width: fit-content;" id="download-all">Download All</a>
    @foreach ( $links as $index=> $link)
        <tr>
            <td>{{$link['link']}}</td>
            <td>
                <img id="svg-{{$loop->iteration}}" width="150px" height="150px" src="{{ asset($link['QR']) }}" alt="QR">
            </td>
            <td>
                <a href="#" class="download-link" onclick="convertSvgToImage('svg-{{$loop->iteration}}','{{$link['id']}}')">Download</a>
            </td>

            <!-- Add more columns as needed -->
        </tr>
    @endforeach
    </tbody>
</table>
<script>
    function convertSvgToImage(svgId,n) {
        const svgElement = document.getElementById(svgId);
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');
        const img = new Image();

        img.onload = function () {
            canvas.width = img.width;
            canvas.height = img.height;
            context.drawImage(img, 0, 0, img.width, img.height);
            canvas.toBlob(function (blob) {
                const url = URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', n+ '_image.png'); // Change 'image.png' to 'image.jpg' for JPG format
                link.click();
                URL.revokeObjectURL(url);
            });
        };

        img.src = svgElement.src;
    }
</script>
<script>
    document.getElementById('download-all').addEventListener('click', function () {
        const zip = new JSZip();
        const promises = [];

        // Loop through all SVG elements
        document.querySelectorAll('img[id^="svg-"]').forEach(function (svgElement) {
            const id = svgElement.id.replace('svg-', '');
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            const img = new Image();

            // Create a new promise for each image conversion
            const promise = new Promise(function (resolve) {
                img.onload = function () {
                    canvas.width = img.width;
                    canvas.height = img.height;
                    context.drawImage(img, 0, 0, img.width, img.height);

                    canvas.toBlob(function (blob) {
                        zip.file(id + '_image.png', blob);
                        resolve();
                    });
                };
            });

            promises.push(promise);
            img.src = svgElement.src;
        });

        // Wait for all promises to resolve and then generate the ZIP file
        Promise.all(promises).then(function () {
            zip.generateAsync({type: 'blob'}).then(function (content) {
                saveAs(content, 'qr_images.zip');
            });
        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
</body>
</html>

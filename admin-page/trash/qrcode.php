<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Download</title>
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
</head>
<body>
    <div id="qrcode"></div>
    <button id="downloadButton">Tải Mã QR</button>

    <script>
        // Dữ liệu bạn muốn chuyển thành mã QR
        const data = "Hello, QR Code!";
        
        // Tạo một đối tượng QRCode
        const qrcode = new QRCode(document.getElementById("qrcode"), {
            text: data,
            width: 128, // Độ rộng của mã QR (có thể điều chỉnh)
            height: 128 // Độ cao của mã QR (có thể điều chỉnh)
        });

        // Xử lý sự kiện khi nút Tải Mã QR được nhấn
        const downloadButton = document.getElementById("downloadButton");
        downloadButton.addEventListener("click", () => {
            // Lấy thẻ canvas chứa mã QR
            const qrCodeCanvas = document.querySelector("#qrcode canvas");

            // Chuyển đổi thẻ canvas thành URL dữ liệu hình ảnh PNG
            const qrCodeDataURL = qrCodeCanvas.toDataURL("image/png");

            // Tạo một liên kết tải xuống cho mã QR
            const link = document.createElement("a");
            link.href = qrCodeDataURL;
            link.download = "qrcode.png"; // Tên tệp tải xuống
            link.click();
        });
    </script>
</body>
</html>

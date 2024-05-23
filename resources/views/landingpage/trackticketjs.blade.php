<div class="modal fade" id="trackResultModal" tabindex="-1" role="dialog" aria-labelledby="trackResultModalLabel"
    aria-hidden="true">
    <!-- Modal untuk menampilkan hasil pelacakan tiket -->

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="trackResultModalLabel">Ticket Tracking Result</h5>
                <!-- Judul modal -->

                <button type="button" class="close" data-dismiss="modal" id="closeModalX">
                    <span aria-hidden="true">&times;</span>
                </button>
                <!-- Tombol penutup modal -->
            </div>

            <div class="modal-body">
                <!-- Isi modal -->

                <p id="userName">Nama Pengadu: No user name found.</p>
                <!-- Informasi nama pengadu -->
                <p id="ticketStatus">Status Pengaduan: No ticket status found.</p>
                <!-- Informasi status pengaduan -->
                <p id="ticketTitle">Judul Pengaduan: No ticket title found.</p>
                <!-- Informasi judul pengaduan -->
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="closeModalButton">Close</button>
                <!-- Tombol untuk menutup modal -->
            </div>
        </div>
    </div>
</div>

<script src="assets/js/ticket.js"></script>
<!-- Mengimpor script eksternal ticket.js -->

<script>
    $(document).ready(function() {
        // Fungsi yang akan dijalankan ketika halaman selesai dimuat

        $('#trackComplaintForm').submit(function(event) {
            event.preventDefault(); // Mencegah pengiriman formulir secara biasa

            var form = $(this); // Mengambil referensi form yang disubmit
            var formData = form
                .serialize(); // Mengambil data formulir dalam format yang sesuai untuk dikirim
            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: formData,
                success: handleSuccess,
                error: handleError
            });
        });

        // Tambahkan event listener untuk modal disembunyikan di sini
        $('#trackComplaintModal').on('hidden.bs.modal', function(e) {
            // Fungsi yang akan dijalankan ketika modal disembunyikan
            resetForm();
        });

        // ... (Fungsi handleSuccess, handleError, updateModalContent, dan showModal Anda)

        function resetForm() {
            // Fungsi untuk mereset form
            $('#trackComplaintForm').trigger("reset");
        }

        function handleSuccess(response) {
            // Menangani respons sukses dari permintaan AJAX

            var userName = response.userName ? maskString(response.userName, 3) : 'No user name found.';
            var ticketStatus = response.ticketStatus ? response.ticketStatus : 'No ticket status found.';
            var ticketTitle = response.ticketTitle ? maskString(response.ticketTitle, 3) :
                'No ticket title found.';

            updateModalContent(userName, ticketStatus, ticketTitle);
            showModal();
        }

        function handleError() {
            // Menangani kesalahan dalam permintaan AJAX

            var errorMessage = 'An error occurred while tracking the ticket.';
            updateModalContent(errorMessage, errorMessage, errorMessage);
            showModal();
        }

        function updateModalContent(userName, ticketStatus, ticketTitle) {
            // Memperbarui konten modal dengan informasi yang diterima dari server

            $('#userName').text(`Nama Pengadu: ${userName}`);
            $('#ticketStatus').text(`Status Pengaduan: ${ticketStatus}`);
            $('#ticketTitle').text(`Judul Pengaduan: ${ticketTitle}`);
        }

        function showModal() {
            // Menampilkan modal

            $('#trackResultModal').modal('show');
        }

        function maskString(inputString, visibleChars) {
            // Fungsi untuk menyembunyikan sebagian karakter dalam string

            return inputString.substr(0, 3) + '*'.repeat(inputString.length - 3);
        }
    });
</script>

<div>
    <!-- Modal Delete -->
    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    @if ($nama_pekerja)
                        Yakin mau hapus data <strong>{{ $nama_pekerja }}</strong>?
                    @else
                        Yakin mau hapus data ini?
                    @endif
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button wire:click="delete" class="btn btn-danger">
                        Hapus
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>
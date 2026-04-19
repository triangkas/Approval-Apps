@props(['url'])

@if ($url)
    <script type="text/javascript">
        async function detailData(id) {
            const timeout = 30000; // 30 detik
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), timeout);
            let url = @json($url).replace(':id', id);

            $('#DetailModal').modal('toggle');
            $('#detailBtnEdit').show();
            $('#detailInfo').html('Loading...');

            try {
                let response = await fetch(url, {
                    signal: controller.signal
                });
                clearTimeout(timeoutId);
                let json = await response.json();
                $('#detailInfo').html(json);
            } catch (error) {
                $('#detailInfo').html('Terjadi kesalahan dalam pengambilan data.');
            }
            return false;
        }
    </script>

    <div class="modal fade show" id="DetailModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-info modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h4 class="ml-3 mt-2"><i class="icon fas fa-book-reader fa-lg mr-2"></i> Detail Data</h4>
                    <div id="detailInfo" class="mt-4"></div>
                </div>
                <div class="modal-footer" style="border-top: 0; justify-content: flex-start;">
                    <button type="button" class="btn btn-primary btn-sm me-4 pl-3 pr-4" data-dismiss="modal"><i
                            class="fas fa-check-circle mr-1"></i> Ok</button>
                </div>
            </div>
        </div>
    </div>
@endif

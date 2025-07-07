<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="messageModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" id="contactMessage">

            </div>
        </div>
    </div>

</div>


@section('script')
<script>
    $(document).ready(function () {
        $('.viewMessage').on('click', function (e) {
            e.preventDefault();

            let contactId = $(this).data('id');
            console.log(contactId);

            $.ajax({
                url: '/contact/show/message/' + contactId,
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    $('#messageModalLabel').text(response.name);
                    $('#contactMessage').text(response.message);
                    $('#messageModal').modal('show');
                },
                error: function () {
                    alert('Failed to load the message.');
                }
            });
        });

    });
</script>
@endsection


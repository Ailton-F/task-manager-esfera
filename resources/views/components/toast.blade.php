<div class="toast-container position-fixed bottom-0 end-0 p-3">
    @if(Session::has('error'))
    <div class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true" id="errorToast">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                {{ Session::get('error') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    @endif
    
    @if(Session::has('success'))
    <div class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" id="successToast">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ Session::get('success') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    @endif
    
    @if(Session::has('warning'))
    <div class="toast align-items-center text-dark bg-warning border-0" role="alert" aria-live="assertive" aria-atomic="true" id="warningToast">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ Session::get('warning') }}
            </div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    @endif
    
    @if(Session::has('info'))
    <div class="toast align-items-center text-white bg-info border-0" role="alert" aria-live="assertive" aria-atomic="true" id="infoToast">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-info-circle-fill me-2"></i>
                {{ Session::get('info') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    @endif
    
    @if($errors->any())
    <div class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true" id="validationErrorToast">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                <strong>Erro de validação</strong>
                <ul class="mb-0 ps-3 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    @endif
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var toastElList = [].slice.call(document.querySelectorAll('.toast'));
        var toastList = toastElList.map(function(toastEl) {
            return new bootstrap.Toast(toastEl, {
                autohide: true,
                delay: 5000
            });
        });
        
        toastList.forEach(toast => toast.show());
    });
</script>
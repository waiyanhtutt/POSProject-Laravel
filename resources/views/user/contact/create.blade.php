<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <form action="{{route('contact#store')}}" method="POST" class=" w-100">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactModalLabel">Contact Us</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class=" form-label">Name</label>
                        <input type="text" class=" form-control" name="name" id="name" value="{{old('name')}}">
                        @error('name')
                            <div class=" text-danger text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class=" form-label">Email</label>
                        <input type="email" class=" form-control" name="email" id="email" value="{{old('email')}}">
                        @error('email')
                            <div class=" text-danger text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="message" class=" form-label">Message</label>
                        <textarea name="message" id="message" class=" form-control" cols="30" rows="5">{{old('message')}}</textarea>
                        @error('message')
                            <div class=" text-danger text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class=" btn btn-warning">Send Message</button>
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal" >Close</button>
                </div>
            </div>
        </form>
    </div>
</div>


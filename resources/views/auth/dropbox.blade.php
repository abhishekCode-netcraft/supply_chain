<form action="{{ route('upload.file') }}" method='POST' enctype='multipart/form-data'>
    @csrf
    <input type='file' name="file" />
    <button type="submit">Submit</button>
</form>
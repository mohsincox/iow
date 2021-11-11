<form action="{{ route('test') }}" method="post">
    @csrf

    <input type="text" name="name">
    <input type="submit">

    <p>{{ $rescent }}</p>
</form>
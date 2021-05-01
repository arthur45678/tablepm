Hi Name: {{$data['name']}}
<p>
    Your registration is completed. Please click the link ot get access.
</p>

{{ route('confirmation.advertisersUser', ['token' => $data['token']]) }}
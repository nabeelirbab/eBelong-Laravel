<p>Hello Admin,</p>

<p>The new user joined as a "{{ $data['role'] }}" to eBelong.</p>

<p>Details are give below:</p>
<ul>
    <li><strong>First Name:</strong>  {{ $data['first_name'] }}</li>
    <li><strong>Last Name:</strong>  {{ $data['last_name'] }}</li>
    <li><strong>Email:</strong>  {{ $data['email'] }}</li>
    <li><strong>Role:</strong>  {{ $data['role'] }}</li>
</ul>
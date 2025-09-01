@extends('app')

@section('main')
<h1>Registrar</h1>
<form id="registerForm">
  <input type="text" id="name" placeholder="Nome" required>
  <input type="email" id="email" placeholder="E-mail" required>
  <input type="password" id="password" placeholder="Senha" required>
  <input type="password" id="password_confirmation" placeholder="Confirme a senha" required>
  <button type="submit">Registrar</button>
</form>

<script>
  document.getElementById('registerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const password_confirmation = document.getElementById('password_confirmation').value;

    axios.post('/api/register', {
        name,
        email,
        password,
        password_confirmation
      })
      .then(res => {
        localStorage.setItem('token', res.data.token);
        window.location.href = '/dashboard';
      })
      .catch(err => alert('Erro no registro'));
  });
</script>
@endsection
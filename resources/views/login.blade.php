@extends('app')

@section('main')
<h1>Login</h1>
<form id="loginForm">
  <input type="email" id="email" placeholder="Email" required>
  <input type="password" id="password" placeholder="Senha" required>
  <button type="submit">Entrar</button>
</form>

<script>
  const api = axios.create({
    baseURL: '/api'
  });

  document.getElementById('loginForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    try {
      const {
        data
      } = await api.post('/login', {
        email: document.getElementById('email').value,
        password: document.getElementById('password').value
      });
      localStorage.setItem('token', data.token);
      window.location.href = '/dashboard';
    } catch (err) {
      alert('Login inválido');
    }
  });
</script>
@endsection
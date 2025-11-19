<?php
use App\Livewire\Actions\Logout;
use function Livewire\Volt\action;
use function Livewire\Volt\on;

// Action de déconnexion
$logout = action(function (Logout $logoutAction) {
    $logoutAction();
    $this->redirect('/', navigate: true);
});

// Écoute l’événement envoyé par SweetAlert
on('logout', fn() => $logout());
?>

<nav class="flex gap-4">
    <a href="#"
       class=""
       onclick="
          event.preventDefault();
          Swal.fire({
             title: 'Déconnexion',
             text: 'Voulez-vous vraiment vous déconnecter ?',
             icon: 'warning',
             showCancelButton: true,
             confirmButtonText: 'Oui',
             cancelButtonText: 'Annuler',
          }).then((result) => {
             if (result.isConfirmed) {
                Livewire.dispatch('logout');
             }
          });
       ">
       Déconnexion
    </a>
</nav>

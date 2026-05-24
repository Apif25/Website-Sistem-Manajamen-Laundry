<?php

namespace App\Livewire\Pekerja\Security;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Services\AccessCodeService;

#[Layout('backend.layouts.app')]
class VerifyAccessCode extends Component
{
    public string $access_code = '';
    public string $redirectTo = '';

    protected AccessCodeService $accessCodeService;

    public function boot(AccessCodeService $accessCodeService)
    {
        $this->accessCodeService = $accessCodeService;
    }

    public function mount()
    {
        $this->redirectTo = request('redirect') ?? route('pekerja.dashboard');
    }

    public function updatedAccessCode()
    {
        $this->resetErrorBag('access_code');
    }

    public function verify()
    {
        $this->validate([
            'access_code' => 'required',
        ]);

        $pekerja = auth('pekerja')->user();

        if (! $pekerja || ! $pekerja->access_code) {
            return redirect()->route('pekerja.access-code.create');
        }

        // Sudah mencapai batas percobaan
        if ($this->accessCodeService->tooManyAttempts($pekerja)) {

            $this->accessCodeService->logout();

            return redirect()
                ->route('pekerja.login')
                ->with(
                    'error',
                    'Anda telah 3 kali memasukkan kode akses yang salah dan telah dikeluarkan dari sistem.'
                );
        }

        // Kode salah
        if (! $this->accessCodeService->verify($pekerja, $this->access_code)) {

            $this->accessCodeService->hitAttempt($pekerja);

            $remaining = $this->accessCodeService->remainingAttempts($pekerja);

            // Jika percobaan ke-3
            if ($remaining <= 0) {

                $this->accessCodeService->logout();

                return redirect()
                    ->route('pekerja.login')
                    ->with(
                        'error',
                        'Anda telah 3 kali memasukkan kode akses yang salah dan telah dikeluarkan dari sistem.'
                    );
            }

            $this->addError(
                'access_code',
                "Kode akses salah. Sisa percobaan: {$remaining}"
            );

            return;
        }

        // Berhasil
        $this->accessCodeService->clearAttempts($pekerja);

        $this->accessCodeService->markVerified();

        return redirect(
            $this->redirectTo ?: route('pekerja.dashboard')
        );
    }

    public function render()
    {
        return view('livewire.pekerja.security.verify-access-code');
    }
}

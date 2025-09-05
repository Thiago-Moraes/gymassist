<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Academia\Contract\AcademiaRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\AcademiaRepository;
use App\Domain\Filial\Contract\FilialRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\FilialRepository;
use App\Domain\Aluno\Contract\AlunoRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\AlunoRepository;
use App\Domain\Aparelho\Contract\AparelhoRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\AparelhoRepository;
use App\Domain\FichaDeTreino\Contract\FichaDeTreinoRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\FichaDeTreinoRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AcademiaRepositoryInterface::class, AcademiaRepository::class);
        $this->app->bind(FilialRepositoryInterface::class, FilialRepository::class);
        $this->app->bind(AlunoRepositoryInterface::class, AlunoRepository::class);
        $this->app->bind(AparelhoRepositoryInterface::class, AparelhoRepository::class);
        $this->app->bind(FichaDeTreinoRepositoryInterface::class, FichaDeTreinoRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

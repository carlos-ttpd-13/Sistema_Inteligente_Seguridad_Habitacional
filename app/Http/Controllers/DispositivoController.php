<?php

namespace App\Http\Controllers;

use App\Models\Dispositivo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DispositivoController extends Controller
{
    /**
     * Muestra el listado de dispositivos.
     */
    public function index(): Response
    {
        $dispositivos = Dispositivo::with('usuario')
            ->latest()
            ->paginate(15);

        return Inertia::render('Dispositivos/Index', [
            'dispositivos' => $dispositivos,
        ]);
    }

    /**
     * Muestra el formulario para crear un dispositivo.
     */
    public function create(): Response
    {
        return Inertia::render('Dispositivos/Create');
    }

    /**
     * Almacena un nuevo dispositivo.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_usuario'  => ['required', 'exists:usuarios,id_usuario'],
            'tipo'        => ['required', 'string', 'max:255'],
            'ubicacion'   => ['nullable', 'string', 'max:255'],
            'estado'      => ['required', 'in:activo,inactivo'],
        ]);

        Dispositivo::create($validated);

        return redirect()->route('dispositivos.index')
            ->with('success', 'Dispositivo creado correctamente.');
    }

    /**
     * Muestra un dispositivo específico.
     */
    public function show(Dispositivo $dispositivo): Response
    {
        $dispositivo->load(['usuario', 'eventos' => fn ($q) => $q->latest()->limit(20), 'accesos' => fn ($q) => $q->latest()->limit(20)]);

        return Inertia::render('Dispositivos/Show', [
            'dispositivo' => $dispositivo,
        ]);
    }

    /**
     * Muestra el formulario para editar un dispositivo.
     */
    public function edit(Dispositivo $dispositivo): Response
    {
        return Inertia::render('Dispositivos/Edit', [
            'dispositivo' => $dispositivo,
        ]);
    }

    /**
     * Actualiza un dispositivo existente.
     */
    public function update(Request $request, Dispositivo $dispositivo): RedirectResponse
    {
        $validated = $request->validate([
            'tipo'      => ['required', 'string', 'max:255'],
            'ubicacion' => ['nullable', 'string', 'max:255'],
            'estado'    => ['required', 'in:activo,inactivo'],
        ]);

        $dispositivo->update($validated);

        return redirect()->route('dispositivos.index')
            ->with('success', 'Dispositivo actualizado correctamente.');
    }

    /**
     * Elimina un dispositivo.
     */
    public function destroy(Dispositivo $dispositivo): RedirectResponse
    {
        $dispositivo->delete();

        return redirect()->route('dispositivos.index')
            ->with('success', 'Dispositivo eliminado correctamente.');
    }
}

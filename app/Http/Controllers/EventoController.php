<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EventoController extends Controller
{
    /**
     * Muestra el listado de eventos.
     */
    public function index(Request $request): Response
    {
        $query = Evento::with('dispositivo')->latest('fecha_hora');

        if ($request->filled('nivel')) {
            $query->where('nivel', $request->nivel);
        }

        if ($request->filled('dispositivo')) {
            $query->where('id_dispositivo', $request->dispositivo);
        }

        $eventos = $query->paginate(20)->withQueryString();

        return Inertia::render('Eventos/Index', [
            'eventos' => $eventos,
            'filtros' => $request->only(['nivel', 'dispositivo']),
        ]);
    }

    /**
     * Muestra el formulario para registrar un evento.
     */
    public function create(): Response
    {
        return Inertia::render('Eventos/Create');
    }

    /**
     * Almacena un nuevo evento.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_dispositivo' => ['required', 'exists:dispositivos,id_dispositivo'],
            'tipo_evento' => ['required', 'string', 'max:255'],
            'nivel' => ['required', 'in:info,warning,critical'],
            'fecha_hora' => ['required', 'date'],
            'descripcion' => ['nullable', 'string'],
        ]);

        Evento::create($validated);

        return redirect()->route('eventos.index')
            ->with('success', 'Evento registrado correctamente.');
    }

    /**
     * Muestra un evento específico.
     */
    public function show(Evento $evento): Response
    {
        $evento->load(['dispositivo', 'alertas.usuario']);

        return Inertia::render('Eventos/Show', [
            'evento' => $evento,
        ]);
    }

    /**
     * Muestra el formulario para editar un evento.
     */
    public function edit(Evento $evento): Response
    {
        return Inertia::render('Eventos/Edit', [
            'evento' => $evento,
        ]);
    }

    /**
     * Actualiza un evento existente.
     */
    public function update(Request $request, Evento $evento): RedirectResponse
    {
        $validated = $request->validate([
            'tipo_evento' => ['required', 'string', 'max:255'],
            'nivel' => ['required', 'in:info,warning,critical'],
            'fecha_hora' => ['required', 'date'],
            'descripcion' => ['nullable', 'string'],
        ]);

        $evento->update($validated);

        return redirect()->route('eventos.index')
            ->with('success', 'Evento actualizado correctamente.');
    }

    /**
     * Elimina un evento.
     */
    public function destroy(Evento $evento): RedirectResponse
    {
        $evento->delete();

        return redirect()->route('eventos.index')
            ->with('success', 'Evento eliminado correctamente.');
    }
}

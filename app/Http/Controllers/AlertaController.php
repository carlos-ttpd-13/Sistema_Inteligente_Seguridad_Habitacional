<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AlertaController extends Controller
{
    /**
     * Muestra el listado de alertas.
     */
    public function index(Request $request): Response
    {
        $query = Alerta::with(['evento.dispositivo', 'usuario'])
            ->latest('fecha');

        if ($request->filled('leida')) {
            $query->where('leida', filter_var($request->leida, FILTER_VALIDATE_BOOLEAN));
        }

        if ($request->filled('canal')) {
            $query->where('canal', $request->canal);
        }

        $alertas = $query->paginate(20)->withQueryString();

        return Inertia::render('Alertas/Index', [
            'alertas' => $alertas,
            'filtros' => $request->only(['leida', 'canal']),
        ]);
    }

    /**
     * Muestra el formulario para crear una alerta.
     */
    public function create(): Response
    {
        return Inertia::render('Alertas/Create');
    }

    /**
     * Almacena una nueva alerta.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_evento'  => ['nullable', 'exists:eventos,id_evento'],
            'id_usuario' => ['required', 'exists:usuarios,id_usuario'],
            'mensaje'    => ['required', 'string'],
            'canal'      => ['required', 'in:web,email,sms,push'],
            'leida'      => ['boolean'],
            'fecha'      => ['required', 'date'],
        ]);

        Alerta::create($validated);

        return redirect()->route('alertas.index')
            ->with('success', 'Alerta creada correctamente.');
    }

    /**
     * Muestra una alerta específica y la marca como leída.
     */
    public function show(Alerta $alerta): Response
    {
        // Marcar como leída automáticamente al ver el detalle
        if (! $alerta->leida) {
            $alerta->update(['leida' => true]);
        }

        $alerta->load(['evento.dispositivo', 'usuario']);

        return Inertia::render('Alertas/Show', [
            'alerta' => $alerta,
        ]);
    }

    /**
     * Muestra el formulario para editar una alerta.
     */
    public function edit(Alerta $alerta): Response
    {
        return Inertia::render('Alertas/Edit', [
            'alerta' => $alerta,
        ]);
    }

    /**
     * Actualiza una alerta existente.
     */
    public function update(Request $request, Alerta $alerta): RedirectResponse
    {
        $validated = $request->validate([
            'mensaje' => ['required', 'string'],
            'canal'   => ['required', 'in:web,email,sms,push'],
            'leida'   => ['boolean'],
        ]);

        $alerta->update($validated);

        return redirect()->route('alertas.index')
            ->with('success', 'Alerta actualizada correctamente.');
    }

    /**
     * Marca una alerta como leída (PATCH conveniente).
     */
    public function marcarLeida(Alerta $alerta): RedirectResponse
    {
        $alerta->update(['leida' => true]);

        return back()->with('success', 'Alerta marcada como leída.');
    }

    /**
     * Elimina una alerta.
     */
    public function destroy(Alerta $alerta): RedirectResponse
    {
        $alerta->delete();

        return redirect()->route('alertas.index')
            ->with('success', 'Alerta eliminada correctamente.');
    }
}

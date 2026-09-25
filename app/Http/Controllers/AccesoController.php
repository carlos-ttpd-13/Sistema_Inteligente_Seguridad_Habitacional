<?php

namespace App\Http\Controllers;

use App\Models\Acceso;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AccesoController extends Controller
{
    /**
     * Muestra el historial de accesos.
     */
    public function index(Request $request): Response
    {
        $query = Acceso::with(['usuario', 'dispositivo'])
            ->latest('fecha_hora');

        if ($request->filled('resultado')) {
            $query->where('resultado', $request->resultado);
        }

        if ($request->filled('metodo')) {
            $query->where('metodo', $request->metodo);
        }

        if ($request->filled('usuario')) {
            $query->where('id_usuario', $request->usuario);
        }

        $accesos = $query->paginate(20)->withQueryString();

        return Inertia::render('Accesos/Index', [
            'accesos' => $accesos,
            'filtros' => $request->only(['resultado', 'metodo', 'usuario']),
        ]);
    }

    /**
     * Muestra el formulario para registrar un acceso.
     */
    public function create(): Response
    {
        return Inertia::render('Accesos/Create');
    }

    /**
     * Registra un nuevo intento de acceso.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_usuario' => ['required', 'exists:usuarios,id_usuario'],
            'id_dispositivo' => ['required', 'exists:dispositivos,id_dispositivo'],
            'metodo' => ['required', 'in:pin,rfid,app'],
            'resultado' => ['required', 'in:exito,denegado'],
            'fecha_hora' => ['required', 'date'],
        ]);

        Acceso::create($validated);

        return redirect()->route('accesos.index')
            ->with('success', 'Acceso registrado correctamente.');
    }

    /**
     * Muestra el detalle de un acceso.
     */
    public function show(Acceso $acceso): Response
    {
        $acceso->load(['usuario', 'dispositivo']);

        return Inertia::render('Accesos/Show', [
            'acceso' => $acceso,
        ]);
    }

    /**
     * Elimina un registro de acceso.
     */
    public function destroy(Acceso $acceso): RedirectResponse
    {
        $acceso->delete();

        return redirect()->route('accesos.index')
            ->with('success', 'Registro de acceso eliminado.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Educator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EducatorController extends Controller
{
    public function index()
    {
        $educator = Educator::all();
        return response()->json(['status' => true, "data" => $educator], 200);
    }

    public function show(string $id)
    {
        $educator = Educator::select('name', 'email', 'phone', 'is_active')->where('id', $id)->first();
        if (!$educator) {
            return response()->json(['status' => false, 'message' => 'Educador não encontrado.'], 404);
        }
        return response()->json(['status' => true, 'educatorData' => $educator], 200);
    }

    public function update(Request $request, string $id)
    {
        $educator = Educator::find($id);

        if (!$educator) {
            return response()->json(['status' => false, 'message' => 'Educador não encontrado.'], 404);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => [
                'sometimes',
                'required',
                'email',
                Rule::unique('educators', 'email')->ignore($id),
            ],
            'phone' => 'sometimes|required|string|max:20',
            'password' => 'sometimes|required|string|min:6',
            'is_active' => 'sometimes|required|boolean',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'is_active']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $educator->update($data);

        $educatorUpdated = Educator::select('name', 'email', 'phone', 'is_active')
            ->where('id', $id)
            ->first();

        return response()->json([
            'status' => true,
            'message' => 'Educador atualizado com sucesso.',
            'educatorData' => $educatorUpdated
        ], 200);
    }

    public function destroy(string $id)
    {
        $educator = Educator::find($id);
        if (!$educator) {
            return response()->json(['status' => false, 'message' => 'Educador não encontrado.'], 404);
        }

        $educator->update(['is_active' => false]);

        return response()->json(['status' => true, 'message' => 'Educador desativado com sucesso.', 'data:' => $educator], 200);
    }
}

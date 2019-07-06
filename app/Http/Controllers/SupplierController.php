<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::orderBy('created_at', 'DESC')->paginate(10);
        return view('supplier.index', compact('suppliers'));
    }

    public function create()
    {
        return view('supplier.add');
    }

    public function save(Request $request)
    {
    //VALIDASI DATA
    $this->validate($request, [
        'id' => 'required|string',
        'name' => 'required|string',
        'phone' => 'required|max:13', //maximum karakter 13 digit
        'address' => 'required|string',
        //unique berarti email ditable karyawans tidak boleh sama
        'email' => 'required|email|string|unique:suppliers,email' // format yag diterima harus email
    ]);

    try {
        $supplier = Supplier::create([
            'id' => $request->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'email' => $request->email
        ]);
        return redirect('/supplier')->with(['success' => 'Data telah disimpan']);
    } catch (\Exception $e) {
        return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function edit($id){
    $supplier = Supplier::find($id);
    return view('supplier.edit', compact('supplier'));
        }

    public function update(Request $request, $id)
{
    $this->validate($request, [
        'id' => 'required|string',
        'name' => 'required|string',
        'phone' => 'required|max:13',
        'address' => 'required|string',
        'email' => 'required|email|string|exists:suppliers,email'
    ]);

    try {
        $supplier = Supplier::find($id);
        $supplier->update([
            'id' => $request->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address
        ]);
        return redirect('/supplier')->with(['success' => 'Data telah diperbaharui']);
    } catch (\Exception $e) {
        return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        $supplier->delete();
        return redirect()->back()->with(['success' => '<strong>' . $supplier->name . '</strong> Telah dihapus']);
    }
}

<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        // $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'                      => ['required', 'string', 'max:255'],
            'email'                     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'                  => ['required', 'string', 'min:8', 'confirmed'],
            'gender'                    => ['required', 'in:M,F,Outro'],
            'nif'                       => ['nullable', 'string', 'max:20', 'unique:users,nif'],
            'default_delivery_address'  => ['nullable', 'string', 'max:255'],
            'default_payment_type'      => ['nullable', 'in:Visa,PayPal,MB WAY'],
            'default_payment_reference' => ['nullable', 'string', 'max:255', 'unique:users,default_payment_reference'],
            // foto é validada no método register abaixo
        ]);
    }

    /**
     * Aqui sobrepomos o método do RegistersUsers para
     * poder validar e processar o ficheiro 'photo'.
     */
    public function register(Request $request)
    {
        // 1) Validar texto + foto
        $this->validator($request->all())->validate();
        $request->validate([
            'photo' => 'nullable|image|max:2048',
        ]);

        // 2) Se houver ficheiro, armazenar em 'storage/app/public/users'
        $photoFilename = null;
        if ($request->hasFile('photo')) {
            // armazena em storage/app/public/users/ e devolve "users/XYZ.jpg"
            $path = $request->file('photo')->store('users', 'public');
            // queremos só o nome sem "users/"
            $photoFilename = basename($path);
        }

        // 3) Criar o utilizador
        $user = User::create([
            'name'                       => $request->name,
            'email'                      => $request->email,
            'password'                   => Hash::make($request->password),
            'gender'                     => $request->gender,
            'nif'                        => $request->nif,
            'default_delivery_address'   => $request->default_delivery_address,
            'default_payment_type'       => $request->default_payment_type,
            'default_payment_reference'  => $request->default_payment_reference,
            'photo'                      => $photoFilename,
        ]);

        // 4) Log in e redireciona
        $this->guard()->login($user);

        return redirect($this->redirectPath());
    }

    // o create() original já não é usado pelo trait
}

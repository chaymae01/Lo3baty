@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4 bg-indigo-600 text-white">
                <h2 class="text-2xl font-bold">Contrat de Partenariat</h2>
            </div>
            
            <div class="p-6">
                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="mb-6 p-4 bg-gray-100 rounded-lg">
                    <p class="text-gray-700">
                        En devenant partenaire, vous acceptez de reverser 15% de vos revenus à l'administrateur de la plateforme.
                        Veuillez signer ce contrat en envoyant les images de votre carte d'identité nationale (CIN).
                    </p>
                </div>

                <form action="{{ route('partenaire.valider') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-6">
                        <label for="cin_recto" class="block text-sm font-medium text-gray-700 mb-2">CIN - Recto :</label>
                        <div class="mt-1 flex items-center">
                            <input type="file" id="cin_recto" name="cin_recto" required
                                   class="block w-full text-sm text-gray-500
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-md file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-indigo-50 file:text-indigo-700
                                          hover:file:bg-indigo-100">
                        </div>
                        @error('cin_recto')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="cin_verso" class="block text-sm font-medium text-gray-700 mb-2">CIN - Verso :</label>
                        <div class="mt-1 flex items-center">
                            <input type="file" id="cin_verso" name="cin_verso" required
                                   class="block w-full text-sm text-gray-500
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-md file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-indigo-50 file:text-indigo-700
                                          hover:file:bg-indigo-100">
                        </div>
                        @error('cin_verso')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="terms" name="terms" type="checkbox" required
                                       class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="terms" class="font-medium text-gray-700">J'accepte les termes du contrat</label>
                                <p class="text-gray-500">Je confirme avoir lu et accepté les conditions du partenariat.</p>
                            </div>
                        </div>
                        @error('terms')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" 
                                class="px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white 
                                       hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 
                                       transition ease-in-out duration-150">
                            Signer et Devenir Partenaire
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
<?php

namespace App\Http\Controllers;

use App\Models\FAQList;
use App\User;
use App\Http\Requests\NewOrgRequest;
use App\Http\Requests\ModifyOrgRequest;
use App\Models\UsersList;
use App\Http\Requests\UserSearchRequest;
use App\Http\Requests\FaqRequest;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{

    protected $FAQList;
    protected $UsersList;

    public function __construct()
    {
        $this->middleware('can:isAdmin');
        $this->FAQList = new FAQList;
        $this->UsersList = new UsersList;
    }

    public function index()
    {
        return view('admin');
    }

    public function AreaRiservata()
    {
        $FAQ = $this->FAQList->getFAQ();
        return view('admin')->with('faqs', $FAQ);
    }

    public function searchUser(UserSearchRequest $request)
    {
        $FAQ = $this->FAQList->getFAQ();
        if ($request->usertype == 'client') {
            $user = $this->UsersList->getUserByUsername($request->name);
        } else {
            $user = $this->UsersList->getOrgByOrgname($request->name);
        }
        return view('admin')->with('user', $user)->with('faqs', $FAQ);
    }

    public function deleteUser($userId)
    {
        $user = $this->UsersList->getUserById($userId);
        $user->delete();
        return redirect()->route('areariservata.admin');
    }

    public function deleteFaq($domanda)
    {
        $faq = $this->FAQList->getSingleFaq($domanda);
        $faq->delete();
        return redirect()->route('areariservata.admin');
    }

    public function modifyFaq(FaqRequest $request)
    {
    }

    public function addFaq(FaqRequest $request)
    {
    }
    /**
     * Gestisce l'indirizzamento alle form di inserimento o modifica organizzatore.
     * Se viene passato l'id dell'organizzatore rimandera l'utente alla form di modifica
     * altrimenti rimanderà alla form di inserimento.
     *
     * @param $orgId Id dell'organizzatore che eventualment si intende modificare
     */
    public function ManageOrg($orgId = null)
    {
        Log::debug("DENTRO MANAGE ORG");
        if ($orgId !== null) {
            $org = $this->UsersList->getUserById($orgId);
            return view('add_and_modify_org')->with('org', $org);
        }
        return view('add_and_modify_org');
    }

    /**
     * Prende dalla richiesta i dati necessati e li inserisce all'interno di un modello di organizzatore
     * poi ritorna alla rotta dell'area riservata dell'admin
     *
     * @param $request Richiesta che arriva dalla form di inserimento di un nuovo organizzatore
     */
    public function InsertOrg(NewOrgRequest $request)
    {
        $org = new User;
        $org->fill($request->validated());
        $org->livello = 3;
        // TODO Fare il check se tutti i campi vengono riempiti correttamente
        $org->save();
        return redirect()->route('areariservata.admin');
    }

    /**
     * Prende i dati dalla richiesta e li inserisce all'interno dell'istanza di organizzatore che si intende modificare
     * poi ritorna alla rotta dell'area riservata dell'admin
     *
     * @param $request Richiesta che arriva dalla form di modifica di un organizzatore
     */
    public function ModifyOrg(ModifyOrgRequest $request)
    {
        $org = $this->UsersList->getUserById($request->idOrg);
        $org->fill($request->validated());
        // TODO Fare il check se tutti i campi vengono riempiti correttamente
        $org->save();
        return redirect()->route('areariservata.admin');
    }
}

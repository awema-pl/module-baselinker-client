<?php

namespace AwemaPL\BaselinkerClient\User\Sections\Accounts\Http\Controllers;

use AwemaPL\BaselinkerClient\User\Sections\Accounts\Http\Requests\StoreAccount;
use AwemaPL\BaselinkerClient\User\Sections\Accounts\Http\Requests\UpdateAccount;
use AwemaPL\BaselinkerClient\User\Sections\Accounts\Models\Account;
use AwemaPL\BaselinkerClient\User\Sections\Accounts\Repositories\Contracts\AccountRepository;
use AwemaPL\BaselinkerClient\User\Sections\Accounts\Resources\EloquentAccount;
use AwemaPL\Auth\Controllers\Traits\RedirectsTo;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AccountController extends Controller
{

    use RedirectsTo, AuthorizesRequests;

    /**
     * Accounts repository instance
     *
     * @var AccountRepository
     */
    protected $accounts;

    public function __construct(AccountRepository $accounts)
    {
        $this->accounts = $accounts;
    }

    /**
     * Display accounts
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('baselinker-client::user.sections.accounts.index');
    }

    /**
     * Request scope
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function scope(Request $request)
    {
        return EloquentAccount::collection(
            $this->accounts->scope($request)
                ->isOwner()
                ->latest()->smartPaginate()
        );
    }

    /**
     * Create account
     *
     * @param StoreAccount $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function store(StoreAccount $request)
    {
        $account = $this->accounts->create($request->all());
        return notify(_p('baselinker-client::notifies.user.account.success_created_account', 'Success created account.'));
    }

    /**
     * Update account
     *
     * @param UpdateAccount $request
     * @param $id
     * @return array
     */
    public function update(UpdateAccount $request, $id)
    {
        $this->authorize('isOwner', Account::find($id));
        $this->accounts->update($request->all(), $id);
        return notify(_p('baselinker-client::notifies.user.account.success_updated_account', 'Success updated account.'));
    }
    
    /**
     * Delete account
     *
     * @param $id
     * @return array
     */
    public function delete($id)
    {
        $this->authorize('isOwner', Account::find($id));
        $this->accounts->delete($id);
        return notify(_p('baselinker-client::notifies.user.account.success_deleted_account', 'Success deleted account.'));
    }

    /**
     * Statuses orderseparations
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function statuses(Request $request, $id)
    {
        $this->authorize('isOwner', Account::find($id));
        $statuses = $this->accounts->statuses($id);
        return $this->ajax($statuses);
    }

    /**
     * Select storage
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function selectStorage(Request $request, $id)
    {
        $this->authorize('isOwner', Account::find($id));
        $statuses = $this->accounts->selectStorage($id);
        return $this->ajax($statuses);
    }
}

<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Controller\BaseController;
use App\Exception\ServiceException;
use App\Model\User\UserAddress;
use App\Request\User\UserAddressesRequest;
use Carbon\Carbon;


class UserAddressesController extends BaseController
{
    public function show()
    {
        /**@var $user \App\Model\User\User * */
        $user = $this->request->getAttribute('user');

        $data = $this->getPaginateData(UserAddress::getList(['user_id' => $user->id]));
        return $this->response->json(responseSuccess(200, '成功', $data));
    }

    public function store(UserAddressesRequest $request)
    {
        /**@var $user \App\Model\User\User * */
        $user = $this->request->getAttribute('user');

        $data = $request->validated();
        $data['user_id'] = $user->id;
        $data['last_used_at'] = Carbon::now();
        UserAddress::query()->create($data);

        return $this->response->json(responseSuccess(201));
    }

    public function update(UserAddressesRequest $request)
    {
        /**@var $user \App\Model\User\User * */
        $user = $this->request->getAttribute('user');

        $data = $request->validated();
        $userAddresses = UserAddress::getFirstById($data['id']);

        if ($user->id != $userAddresses->user_id)
        {
            throw new ServiceException(403, '更新地址错误');
        }

        $userAddresses->update($data);

        return $this->response->json(responseSuccess());
    }

    public function delete(UserAddressesRequest $request)
    {
        /**@var $user \App\Model\User\User * */
        $user = $this->request->getAttribute('user');

        $data = $request->validated();
        $userAddresses = UserAddress::getFirstById($data['id']);

        if ($user->id != $userAddresses->user_id)
        {
            throw new ServiceException(403, '更新地址错误');
        }

        $userAddresses->delete();

        return $this->response->json(responseSuccess());
    }
}

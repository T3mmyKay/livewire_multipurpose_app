<?php

namespace App\Http\Livewire\Admin\Users;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ListUsers extends AdminComponent
{
    public $state = [];

    public $user;
    public $showEditModal = false;

    public $userIdToBeDeleted;

    public function addNewUser()
    {
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-form');
    }

    public function createUser()
    {
        $validated = Validator::make($this->state, [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3',
            'confirm_password' => 'required|same:password',
        ])->validate();
        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);
        // session()->flash('message', 'User Added Successfully');
        $this->state = [];

        $this->dispatchBrowserEvent('hide_form', ['message' => 'User Added Successfully']);
    }

    public function edit(User $user)
    {
        $this->showEditModal = true;
        $this->user = $user;
        $this->state = $user->toArray();
        $this->dispatchBrowserEvent('show-form');
    }

    public function updateUser()
    {
        $validated = Validator::make($this->state, [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,'.$this->user->id,
        ])->validate();

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $this->user->update($validated);
        $this->state = [];
        $this->dispatchBrowserEvent('hide_form', ['message' => 'User Updated Successfully']);
    }

    public function confirmDelete($id)
    {
        $this->userIdToBeDeleted = $id;
        $this->dispatchBrowserEvent('confirmDelete', ['message' => 'Are you sure you want to delete this user?']);
    }

    public function deleteUser()
    {
        User::findOrFail($this->userIdToBeDeleted)->delete();
        $this->dispatchBrowserEvent('hide-delete-modal', ['message' => 'User Deleted Successfully']);
    }

    public function render()
    {
        return view('livewire.admin.users.list-users', ['users' => User::paginate(5)]);
    }
}
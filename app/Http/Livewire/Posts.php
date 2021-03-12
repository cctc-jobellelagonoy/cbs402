<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Crypt;
use Livewire\Component;
use App\Models\Post;
use Auth;

class Posts extends Component
{
    public $posts, $title, $body, $post_id;
    public $isOpen = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function render()
    {
        $this->posts = Post::all();
        return view('livewire.posts');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function openModal()
    {
        $this->isOpen = true;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function closeModal()
    {
        $this->isOpen = false;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    private function resetInputFields(){
        $this->title = '';
        $this->body = '';
        $this->post_id = '';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function store()
    {
        $user = Auth::user();
        $this->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        Post::updateOrCreate(['id' => $this->post_id], [
            'title' => Crypt::encryptString($this->title),
            'body' => Crypt::encryptString($this->body)
        ]);

        session()->flash('message',
            $this->post_id ? 'Post Updated Successfully.' : 'Post Created Successfully.');

        if($this->post_id){
            activity($this->title)
            ->causedBy($user)
            //->withProperties(['customProperty' => 'customValue'])
            ->log('Book updated by ' . Crypt::decryptString($user->name));
        }
        else{
            activity($this->title)
            ->causedBy($user)
            //->withProperties(['customProperty' => 'customValue'])
            ->log('Book created by ' . Crypt::decryptString($user->name));
        }



        $this->closeModal();
        $this->resetInputFields();
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit($id)
    {
        $user = Auth::user();
        $post = Post::findOrFail($id);
        $this->post_id = $id;
        $this->title = Crypt::decryptString($post->title);
        $this->body = Crypt::decryptString($post->body);




        $this->openModal();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        $user = Auth::user();
        $post = Post::findOrFail($id);
        $this->title = Crypt::decryptString($post->title);
        $this->body = Crypt::decryptString($post->body);

        activity($this->title)
        ->causedBy($user)
        //->withProperties(['customProperty' => 'customValue'])
        ->log('Book deleted by ' . Crypt::decryptString($user->name));

        Post::find($id)->delete();
        session()->flash('message', 'Post Deleted Successfully.');

    }
}

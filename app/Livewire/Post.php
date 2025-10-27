<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Post as PostModel;
use Illuminate\Support\Facades\Storage;
use Hekmatinasser\Verta\Verta;
use App\Models\User;

class Post extends Component
{
    use WithFileUploads;

    public $posts, $title, $date, $description, $attachment, $status = 'undone';
    public $postIdBeingUpdated = null;
    public $layout = 'layouts.public';
    public $showModal = false;
    public $selectedUser = null;
    public $search = '';
    public $persianDate, $persianTime;
    public $filterStatus = 'all';
    public $filterUser = null;
    public $users = [];
    public $postAttachement = '';

    protected $rules = [
        'title' => 'required|string|min:3|max:255',
        'persianDate' => 'required|string',
        'description' => 'required|string|min:10|max:1000',
        // 'attachment' => 'required|file|max:2048|mimes:pdf,doc,docx,jpg,jpeg,png',
        'selectedUser' => 'required|exists:users,id',
    ];

    // rules when creating
    protected $createRules = [
        'attachment' => 'required|file|max:2048|mimes:pdf,doc,docx,jpg,jpeg,png',
    ];

    // rules when updating
    protected $updateRules = [
        'attachment' => 'nullable|file|max:2048|mimes:pdf,doc,docx,jpg,jpeg,png',
    ];

    protected $messages = [
        'title.required' => 'عنوان الزامی است',
        'title.string' => 'عنوان باید متن باشد',
        'title.min' => 'عنوان باید حداقل ۳ کاراکتر باشد',
        'title.max' => 'عنوان نباید بیشتر از ۲۵۵ کاراکتر باشد',
        'persianDate.required' => 'تاریخ الزامی است',
        'persianDate.string' => 'تاریخ باید متن باشد',
        'description.required' => 'توضیحات الزامی است',
        'description.string' => 'توضیحات باید متن باشد',
        'description.min' => 'توضیحات باید حداقل ۱۰ کاراکتر باشد',
        'description.max' => 'توضیحات نباید بیشتر از ۱۰۰۰ کاراکتر باشد',
        'attachment.file' => 'پیوست باید یک فایل باشد',
        'attachment.max' => 'حجم فایل نباید بیشتر از ۲ مگابایت باشد',
        'attachment.mimes' => 'فقط فایل‌های PDF، Word و تصاویر مجاز هستند',
        'selectedUser.required' => 'انتخاب کاربر الزامی است',
        'selectedUser.exists' => 'کاربر انتخابی معتبر نیست',
    ];

    public function mount()
    {
        $this->loadPosts();
        $this->loadUsers();
    }
    public function loadUsers()
    {
        $this->users = User::select('users.id', 'users.first_name', 'users.last_name')
            ->get();
    }
    public function loadPosts()
    {
        $this->posts = PostModel::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterStatus, function ($query) {
                if ($this->filterStatus === 'done') {
                    $query->where('status', 'done');
                } elseif ($this->filterStatus === 'undone') {
                    $query->where('status', 'undone');
                }
            })
            ->when($this->filterUser, function ($query) {
                if ($this->filterUser) {
                    $query->where('user_id', $this->filterUser);
                }
            })
            ->latest()
            ->get();
    }

    public function toggleFilterStatus($filter)
    {
        $this->filterStatus = $filter;
        $this->loadPosts();
    }

    public function toggleFilterUser($filter)
    {
        $this->filterUser = $filter;
        $this->loadPosts();
    }


    public function save()
    {
        try {

            // Convert Persian date to datetime
            try {
                $persianDateTime = $this->persianDate . ' ' . ($this->persianTime ?? '00:00');
                $verta = Verta::parse($persianDateTime);
                $gregorianDate = $verta->datetime();
            } catch (\Exception $e) {
                $this->addError('persianDate', 'تاریخ یا زمان وارد شده صحیح نیست. فرمت صحیح: ۱۴۰۳/۰۸/۰۶ و ۱۴:۳۰');
                return;
            }



            if ($this->postIdBeingUpdated) {
                $this->updatePost($gregorianDate);
            } else {
                $this->createPost($gregorianDate);
            }

            $this->reset(['title', 'persianDate', 'postAttachement', 'persianTime', 'description', 'attachment', 'status', 'selectedUser']);
            $this->showModal = false;
            $this->loadPosts();

            session()->flash('message', 'نوشته با موفقیت ذخیره شد!');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function createPost($gregorianDate)
    {
        try {
            $this->validate(array_merge($this->rules, $this->createRules));
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Remove temp file if validation fails
            if ($this->attachment && method_exists($this->attachment, 'delete')) {
                $this->attachment->delete();
            }
            throw $e;
        }
        $path = null;
        if ($this->attachment) {
            $path = $this->attachment->store('attachments', 'public');
        }
        $this->status = 'undone';
        PostModel::create([
            'title' => $this->title,
            'date' => $gregorianDate,
            'user_id' => $this->selectedUser,
            'description' => $this->description,
            'attachment' => $path,
            'status' => $this->status,
        ]);
    }


    public function updatePost($gregorianDate)
    {
        try {
            $this->validate(array_merge($this->rules, $this->updateRules));
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Remove temp file if validation fails
            if ($this->attachment && method_exists($this->attachment, 'delete')) {
                $this->attachment->delete();
            }
            throw $e;
        }
        $post = PostModel::find($this->postIdBeingUpdated);

        $updateData = [
            'title' => $this->title,
            'date' => $gregorianDate,
            'description' => $this->description,
            'status' => $this->status,
        ];

        $path = null;
        if ($this->attachment) {
            $path = $this->attachment->store('attachments', 'public');
        }
        if ($path) {
            // Delete old attachment if exists
            if ($post->attachment) {
                if ($post->attachment) {
                    Storage::disk('public')->delete($post->attachment);

                    // Cleanup Livewire temp upload
                    if ($this->attachment && method_exists($this->attachment, 'temporaryUrl')) {
                        $this->attachment = null;
                    }
                }
            }
            $updateData['attachment'] = $path;
        }

        $post->update($updateData);
        $this->postIdBeingUpdated = null;
    }
    public function edit($id)
    {
        $post = PostModel::find($id);
        $this->postIdBeingUpdated = $id;
        $this->title = $post->title;

        // Convert date to Persian
        if ($post->date) {
            $verta = Verta::instance($post->date);
            $this->persianDate = $verta->format('Y/m/d');
            $this->persianTime = $verta->format('H:i');
        }

        $this->description = $post->description;
        $this->attachment = null;
        $this->postAttachement = $post->attachment; // user must upload new file
        $this->status = $post->status->value;
        $this->selectedUser = $post->user_id; // Default user, you can modify this based on your needs
        $this->showModal = true;
    }

    public function delete($id)
    {
        $post = PostModel::find($id);
        Storage::disk('public')->delete($post->attachment);
        // Check and delete from livewire-tmp if exists
        if ($post->attachment) {
            $fileName = basename($post->attachment);
            $livewireTmpPath = 'livewire-tmp/' . $fileName;
            if (Storage::disk('local')->exists($livewireTmpPath)) {
                Storage::disk('local')->delete($livewireTmpPath);
            }
        }
        $post->delete();
        $this->loadPosts();
    }

    public function toggleStatus($id)
    {
        $post = PostModel::find($id);
        $post->status = $post->status === 'done' ? 'undone' : 'done';
        $post->save();
        $this->loadPosts();
    }

    public function openModal()
    {
        $this->showModal = true;
        $this->reset(['title', 'persianDate', 'persianTime', 'description', 'attachment', 'status', 'postIdBeingUpdated', 'selectedUser']);
        $this->status = 'undone';

        // Set current Persian date as default
        $today = Verta::now();
        $this->persianDate = $today->format('Y/m/d');
        $this->persianTime = $today->format('H:i');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['title', 'persianDate', 'persianTime', 'description', 'attachment', 'status', 'postIdBeingUpdated', 'selectedUser']);
        $this->status = 'undone';
        $this->resetErrorBag();
    }

    public function render()
    {
        if ($this->search != '') {
            $this->loadPosts();
        }
        return view('livewire.posts.post')->layout('layouts.public');
    }
}

@props(['old_values' => $oldvalues])


<div>
    <label for="title">{{ __('Title') }}</label>
    <textarea name="post[title]" id="title" cols="30" rows="2" class="w-full rounded-lg border-2 bg-gray-100 @error('title') border-red-500 @enderror"
    placeholder="～講義の～レポートを解く会" >{{ $old_values['title'] }}</textarea>
    
    @error('post.title')
    <div class="text-red-500 text-sm mt-1">
        {{ $message }}
    </div>
    @enderror
</div>


<div class="mt-4">
    <label for="start_at"></label>{{ __('Start Time') }}</label>
    <input name="post[start_at]" id="start_at" type="datetime-local" min="2023-10-01T12:00" value="{{ $old_values['start_at'] }}" 
    class="mt-1 block w-full py-2 px-3 border-2 bg-gray-100 rounded-lg shadow-sm focus:outline-none sm:text-sm @error('start_at') border-red-500 @enderror"/>
    
    @error('post.start_at')
    <div class="text-red-500 text-sm mt-2">
        {{ $message }}
    </div>
    @enderror
</div>


<div class="mt-4">
    <label for="place">{{ __('Place') }}</label>
    <textarea name="post[place]" id="place" cols="30" rows="1" class="w-full rounded-lg border-2 bg-gray-100 @error('place') border-red-500 @enderror"
    placeholder="～棟～番教室">{{ $old_values['place'] }}</textarea>
    
    @error('post.place')
    <div class="text-red-500 text-sm mt-1">
        {{ $message }}
    </div>
    @enderror
</div>


<div class="mt-4 grid grid-cols-12 gap-2">
    <label for="lectures" class="col-span-7">{{ __('Lecture Tag') }}</label>
    <label for="lecsearchbox" class="col-span-5">{{ __('Filtering') }}</label>
    <select name="post[lecture_id]" id="lectures" class="col-span-7 flex py-2 border-2 bg-gray-100 rounded-lg shadow-sm focus:outline-none sm:text-sm"></select>
    <input type="text" id="lecsearchbox" placeholder="e.g. 量子" class="col-span-5 py-2 border-2 flex bg-gray-100 rounded-lg shadow-sm focus:outline-none sm:text-sm">
</div>

<div class="mt-4 grid grid-cols-12 gap-2">
    <label for="tags" class="col-span-7">{{ __('Tags (optional)') }}</label>
    <label for="tagsearchbox" class="col-span-5">{{ __('Filtering') }}</label>
    <select name="post[tag_id]" id="tags" class="col-span-7 flex py-2 border-2 bg-gray-100 rounded-lg shadow-sm focus:outline-none sm:text-sm"></select>
    <input type="text" id="tagsearchbox" placeholder="e.g. 物理" class="col-span-5 py-2 border-2 flex bg-gray-100 rounded-lg shadow-sm focus:outline-none sm:text-sm">
</div>

<div class="mt-4 grid grid-cols-12 gap-2">
    <input type="text" name="tag[name]" id="free_tag" cols="30" rows="1" placeholder="{{ __('Add Free Tag (optional)     e.g. report') }}" class="col-span-10 rounded-lg border-2 bg-gray-100 @error('tag') border-red-500 @enderror"></textarea>
    <button id="tag_add_btn" 
        class="col-span-2 btn py-2 flex-initial text-sm font-medium text-white bg-gray-500 rounded-lg border border-gray-700 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ __('Add') }}</button>
    <p id="exist_alert" class="col-span-12 text-red-500 text-sm mt-1"></p>
    
    {{--
    @error('post.tag')
    <div class="text-red-500 text-sm mt-2">
        {{ $message }}
    </div>
    @enderror
    --}}
    
</div>

<div class="mt-4">
  <label for="body">{{ __('Comment') }}</label>
  <textarea name="post[body]" id="body" cols="30" rows="4" class="w-full rounded-lg border-2 bg-gray-100 @error('comment') border-red-500 @enderror"
  placeholder="今回のレポートは～です!">{{ $old_values['body'] }}</textarea>
  
  @error('post.body')
  <div class="text-red-500 text-sm mt-1 mb-2">
    {{ $message }}
  </div>
  @enderror
</div>

<label for="teacher_welcome">
    <input name="post[teacher_welcome]" type="hidden" value="0"/>
    <input name="post[teacher_welcome]" type="checkbox" value="1" id="teacher_welcome" @if( $old_values['teacher_welcome'] == '1' ) checked @endif />
    {{ __('Welcome those who want to teach') }}
</label>

<div class="mt-4">
    <button type="button" onclick="submit();" class="btn bg-blue-500 rounded font-medium px-4 py-2 text-white hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring :ring-indigo-500">
        {{ __('Submit') }}
    </button>
</div>

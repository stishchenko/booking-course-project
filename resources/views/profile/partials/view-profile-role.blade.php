<section>
    <div>
        <x-input-label for="role" value="User Role"/>
        <x-text-input id="role" name="role" type="text" class="mt-1 block w-full" value="{{ $user->role }}"
                      autofocus readonly/>
    </div>
</section>

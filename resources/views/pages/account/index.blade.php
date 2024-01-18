<x-layout.account>
    <p class="text-base leading-6 text-secondary-600">
        Hello, <span class="font-bold text-secondary-900">{{ Auth::user()->last_name }}</span>
        <span class="text-sm">
            (signed in as: <span class="font-medium text-secondary-900">{{ Auth::user()->email }}</span>)
        </span>
    </p>
    <p class="mt-6 text-sm text-secondary-600 leading-6">
        From your account dashboard you can view your <a href="#" class="font-medium text-secondary-900 underline">recent orders</a>,
        manage your <a href="#" class="font-medium text-secondary-900 underline">shipping and billing addresses</a>, and
        <a href="#" class="font-medium text-secondary-900 underline">edit your password and account details</a>.
    </p>
</x-layout.account>

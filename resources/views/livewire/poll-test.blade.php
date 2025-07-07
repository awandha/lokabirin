<div>
  <div wire:poll.keep-alive.2s>
    <p>Server time: {{ now() }}</p>
  </div>
  <button wire:click="$refresh">Click to refresh</button>
</div>

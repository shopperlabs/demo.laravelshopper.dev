@props(['status'])

<x-status-indicator :title="$status->getLabel()" :variant="$status->getColor()" />

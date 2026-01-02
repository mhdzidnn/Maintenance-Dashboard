import './bootstrap';
import {
    createIcons,
    LayoutDashboard,
    Server,
    Cloud,
    Settings,
    Bell,
    Mail,
    LogOut,
    Search,
    ChevronRight,
    Activity,
    Database,
    Cpu,
    HardDrive,
    AlertTriangle,
    CheckCircle,
    XCircle,
    Info,
    RefreshCw,
    Shield,
    Check,
    Clock,
    User,
    ChevronDown,
    MoreVertical,
    Lock,
    Wrench,
    Trash2,
    FileCheck,
    Camera,
    AlertCircle
} from 'lucide';

import Chart from 'chart.js/auto';
window.Chart = Chart;

// Alpine.js
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

window.initializeLucide = () => {
    createIcons({
        icons: {
            LayoutDashboard,
            Server,
            Cloud,
            Settings,
            Bell,
            Mail,
            LogOut,
            Search,
            ChevronRight,
            Activity,
            Database,
            Cpu,
            HardDrive,
            AlertTriangle,
            CheckCircle,
            XCircle,
            Info,
            RefreshCw,
            Shield,
            Clock,
            User,
            ChevronDown,
            MoreVertical,
            Lock,
            Wrench,
            Trash2,
            FileCheck,
            Camera,
            AlertCircle,
            Check
        }
    });
};

document.addEventListener('DOMContentLoaded', () => {
    window.initializeLucide();
});

document.addEventListener('livewire:navigated', () => {
    window.initializeLucide();
});

// Re-initialize Lucide icons after Livewire updates the DOM
document.addEventListener('livewire:update', () => {
    window.initializeLucide();
});

document.addEventListener('livewire:init', () => {
    window.initializeLucide();
});

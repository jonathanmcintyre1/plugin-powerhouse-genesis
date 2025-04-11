
import React from 'react';
import { cn } from '@/lib/utils';
import {
  Settings, Type, Image, Code, MessageSquare, List, HelpCircle
} from 'lucide-react';

type TabItem = {
  id: string;
  label: string;
  icon: React.ReactNode;
};

interface TabNavigationProps {
  activeTab: string;
  setActiveTab: (tab: string) => void;
}

const TabNavigation: React.FC<TabNavigationProps> = ({ activeTab, setActiveTab }) => {
  const tabs: TabItem[] = [
    { id: 'general', label: 'General Settings', icon: <Settings className="h-5 w-5" /> },
    { id: 'text', label: 'Text Protection', icon: <Type className="h-5 w-5" /> },
    { id: 'image', label: 'Image Protection', icon: <Image className="h-5 w-5" /> },
    { id: 'javascript', label: 'JavaScript Behavior', icon: <Code className="h-5 w-5" /> },
    { id: 'appearance', label: 'Appearance & Messaging', icon: <MessageSquare className="h-5 w-5" /> },
    { id: 'advanced', label: 'Advanced Rules', icon: <List className="h-5 w-5" /> },
    { id: 'help', label: 'Help & Support', icon: <HelpCircle className="h-5 w-5" /> },
  ];

  return (
    <div className="flex flex-col bg-white rounded-lg shadow-md mb-6 p-2 w-64 space-y-1">
      {tabs.map((tab) => (
        <button
          key={tab.id}
          onClick={() => setActiveTab(tab.id)}
          className={cn(
            "flex items-center space-x-3 px-4 py-3 text-left rounded-md transition-all duration-200",
            activeTab === tab.id
              ? "bg-gradient-to-r from-[#6a11cb]/10 to-[#2575fc]/10 text-[#2575fc] font-medium border-l-4 border-[#2575fc]"
              : "text-[#444444] hover:bg-gray-50 hover:scale-[1.02]"
          )}
        >
          <span className={cn(
            "transition-colors duration-200",
            activeTab === tab.id ? "text-[#6a11cb]" : "text-gray-500"
          )}>
            {tab.icon}
          </span>
          <span>{tab.label}</span>
        </button>
      ))}
    </div>
  );
};

export default TabNavigation;

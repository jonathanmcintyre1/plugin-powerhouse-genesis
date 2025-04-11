
import React from 'react';
import { Switch } from '@/components/ui/switch';
import { Label } from '@/components/ui/label';
import { cn } from '@/lib/utils';

interface SwitchGroupProps {
  id: string;
  label: string;
  description?: string;
  checked: boolean;
  onCheckedChange: (checked: boolean) => void;
  disabled?: boolean;
  className?: string;
}

const SwitchGroup: React.FC<SwitchGroupProps> = ({
  id,
  label,
  description,
  checked,
  onCheckedChange,
  disabled = false,
  className,
}) => {
  return (
    <div className={cn("flex flex-row items-center justify-between space-x-4 rounded-lg border p-4 transition-all duration-200", 
      checked 
        ? "bg-gradient-to-r from-[#8B0016]/10 to-[#CC0000]/10 border-[#CC0000]/20" 
        : "bg-white border-[#e0e0e0] hover:border-[#d0d0d0]",
      className
    )}>
      <div className="space-y-0.5">
        <Label htmlFor={id} className="text-base font-medium text-[#333333]">
          {label}
        </Label>
        {description && (
          <p className="text-sm text-[#666666]">{description}</p>
        )}
      </div>
      <Switch
        id={id}
        checked={checked}
        onCheckedChange={onCheckedChange}
        disabled={disabled}
        className={cn(
          "transition-all duration-200",
          checked ? "bg-gradient-to-r from-[#8B0016] to-[#CC0000]" : "bg-gray-200"
        )}
      />
    </div>
  );
};

export default SwitchGroup;

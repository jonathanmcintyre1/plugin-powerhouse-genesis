
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
    <div className={cn("flex flex-row items-center justify-between space-x-4 rounded-lg border p-4", 
      checked ? "bg-purple-50 border-purple-200" : "bg-white border-gray-200",
      className
    )}>
      <div className="space-y-0.5">
        <Label htmlFor={id} className="text-base font-medium">
          {label}
        </Label>
        {description && (
          <p className="text-sm text-muted-foreground">{description}</p>
        )}
      </div>
      <Switch
        id={id}
        checked={checked}
        onCheckedChange={onCheckedChange}
        disabled={disabled}
        className={cn(
          checked ? "bg-purple-600" : "bg-gray-200"
        )}
      />
    </div>
  );
};

export default SwitchGroup;

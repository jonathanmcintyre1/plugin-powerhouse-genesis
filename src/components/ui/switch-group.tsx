
import React from 'react';
import { Switch } from "@/components/ui/switch";
import { Label } from "@/components/ui/label";

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
  className = ""
}) => {
  return (
    <div className={`flex items-start justify-between gap-4 py-3 ${className}`}>
      <div className="space-y-1">
        <Label htmlFor={id} className="text-base font-medium">{label}</Label>
        {description && (
          <p className="text-sm text-muted-foreground">{description}</p>
        )}
      </div>
      <Switch
        id={id}
        checked={checked}
        onCheckedChange={onCheckedChange}
        disabled={disabled}
        aria-label={label}
      />
    </div>
  );
};

export default SwitchGroup;

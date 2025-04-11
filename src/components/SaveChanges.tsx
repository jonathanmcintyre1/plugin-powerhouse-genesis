
import React from 'react';
import { Button } from '@/components/ui/button';
import { cn } from '@/lib/utils';
import { Save, Loader2 } from 'lucide-react';
import { toast } from '@/hooks/use-toast';

interface SaveChangesProps {
  isSaving: boolean;
  onSave: () => void;
  hasChanges: boolean;
  className?: string;
}

const SaveChanges: React.FC<SaveChangesProps> = ({
  isSaving,
  onSave,
  hasChanges,
  className,
}) => {
  const handleSave = () => {
    onSave();
    
    // Show success toast after "saving"
    setTimeout(() => {
      toast({
        title: "Settings saved",
        description: "Your protection settings have been updated.",
      });
    }, 1000);
  };

  return (
    <div className={cn(
      "flex items-center justify-between p-4 border-t bg-gray-50 rounded-b-lg",
      className
    )}>
      <div className="text-sm text-gray-500">
        {hasChanges ? (
          "You have unsaved changes"
        ) : (
          "All changes saved"
        )}
      </div>
      <Button 
        onClick={handleSave}
        disabled={isSaving || !hasChanges}
        className={cn(
          "bg-purple-600 hover:bg-purple-700",
          isSaving ? "opacity-80" : ""
        )}
      >
        {isSaving ? (
          <>
            <Loader2 className="mr-2 h-4 w-4 animate-spin" />
            Saving...
          </>
        ) : (
          <>
            <Save className="mr-2 h-4 w-4" />
            Save Changes
          </>
        )}
      </Button>
    </div>
  );
};

export default SaveChanges;
